const errorHandler = (err, req, res, next) => {
    console.error('💥 Lỗi server:', err);
    
    // Lỗi validation của Joi
    if (err.isJoi) {
        return res.status(400).json({
            success: false,
            message: 'Dữ liệu không hợp lệ',
            errors: err.details.map(detail => detail.message)
        });
    }
    
    // Lỗi database
    if (err.code === 'ER_DUP_ENTRY') {
        return res.status(409).json({
            success: false,
            message: 'Dữ liệu đã tồn tại'
        });
    }
    
    // Lỗi kết nối database
    if (err.code === 'ECONNREFUSED') {
        return res.status(503).json({
            success: false,
            message: 'Không thể kết nối database'
        });
    }
    
    // Lỗi mặc định
    res.status(500).json({
        success: false,
        message: 'Lỗi server nội bộ',
        error: process.env.NODE_ENV === 'development' ? err.message : 'Có lỗi xảy ra'
    });
};

module.exports = errorHandler;