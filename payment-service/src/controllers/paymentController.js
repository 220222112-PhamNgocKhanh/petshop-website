const Payment = require('../models/payment');
const parseRequestBody = require('../utils/parseRequestBody');

// Tạo thanh toán mới
exports.createPayment = (req, res) => {
    parseRequestBody(req, res, async (body) => {
        const { order_id, amount, payment_method } = body;
        const user_id = req.user?.user_id;

        if (!order_id || !amount || !payment_method || !user_id) {
            res.writeHead(400, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'Missing required fields' }));
        }

        try {
            const payment = await Payment.create({
                order_id,
                user_id,
                amount,
                currency: 'USD',
                payment_method,
                status: 'pending',
            });

            res.writeHead(201, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Payment created successfully', payment }));
        } catch (error) {
            console.error('Create payment error:', error);
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Internal server error' }));
        }
    });
};

// Lấy danh sách thanh toán (chỉ admin)
exports.getPayments = async (req, res) => {
    if (req.user.role !== 'admin') {
        res.writeHead(403, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Access denied' }));
    }

    try {
        const payments = await Payment.findAll();
        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify(payments));
    } catch (error) {
        console.error('Get payments error:', error);
        res.writeHead(500, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Internal server error' }));
    }
};

// Lấy chi tiết thanh toán theo ID (chính chủ hoặc admin)
exports.getPaymentById = async (req, res, paymentId) => {
    try {
        const payment = await Payment.findByPk(paymentId);
        if (!payment) {
            res.writeHead(404, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'Payment not found' }));
        }

        const isAdmin = req.user.role === 'admin';
        const isOwner = payment.user_id === req.user.user_id;

        if (!isAdmin && !isOwner) {
            res.writeHead(403, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'Permission denied' }));
        }

        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify(payment));
    } catch (error) {
        console.error('Get payment by ID error:', error);
        res.writeHead(500, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Internal server error' }));
    }
};

// Cập nhật trạng thái (chỉ admin)
exports.updatePaymentStatus = (req, res, paymentId) => {
    if (req.user.role !== 'admin') {
        res.writeHead(403, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Access denied' }));
    }

    parseRequestBody(req, res, async (body) => {
        const { status } = body;

        if (!status || !['pending', 'success', 'failed', 'cancelled'].includes(status)) {
            res.writeHead(400, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'Invalid or missing status' }));
        }

        try {
            const payment = await Payment.findByPk(paymentId);
            if (!payment) {
                res.writeHead(404, { 'Content-Type': 'application/json' });
                return res.end(JSON.stringify({ message: 'Payment not found' }));
            }

            payment.status = status;
            await payment.save();

            res.writeHead(200, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Payment status updated successfully', payment }));
        } catch (error) {
            console.error('Update payment status error:', error);
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Internal server error' }));
        }
    });
};

// Lấy tổng giá trị các đơn hàng thanh toán thành công
exports.getTotalSuccessfulPayments = async (req, res) => {
    try {
        const payments = await Payment.findAll({
            where: {
                status: 'success'
            }
        });

        const totalAmount = payments.reduce((sum, payment) => sum + payment.amount, 0);

        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({
            total_amount: totalAmount,
            currency: 'USD',
            total_transactions: payments.length
        }));
    } catch (error) {
        console.error('Get total successful payments error:', error);
        res.writeHead(500, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Internal server error' }));
    }
};
