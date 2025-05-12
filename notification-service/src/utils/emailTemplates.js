function accountCreated(name) {
  return {
    subject: 'Chào mừng bạn đến với PetShop!',
    body: `Xin chào ${name},<br><br>Tài khoản của bạn đã được tạo thành công. Cảm ơn bạn đã đăng ký!<br><br><b>PetShop Team</b>`,
  };
}

function passwordReset(name, link) {
  return {
    subject: 'Yêu cầu đặt lại mật khẩu',
    body: `Xin chào ${name},<br><br>Chúng tôi nhận được yêu cầu đặt lại mật khẩu của bạn.<br>Bấm vào liên kết sau để tiếp tục: <a href="${link}">Đặt lại mật khẩu</a><br><br><b>PetShop Team</b>`,
  };
}

function orderConfirmation(name, orderId) {
  return {
    subject: `Xác nhận đơn hàng #${orderId}`,
    body: `Xin chào ${name},<br><br>Chúng tôi đã nhận được đơn hàng của bạn (#${orderId}).<br>Cảm ơn bạn đã mua sắm tại PetShop!<br><br><b>PetShop Team</b>`,
  };
}

module.exports = {
  accountCreated,
  passwordReset,
  orderConfirmation, 
};