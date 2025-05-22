function accountCreated(name) {
  return {
      subject: 'Chào mừng bạn đến với PetShop!',
      body: `Xin chào ${name},\n\nTài khoản của bạn đã được tạo thành công. Cảm ơn bạn đã đăng ký!\n\nFrom PetShop Team with love ❤️`
  };
}

function passwordReset(name, newPassword) {
  return {
      subject: 'Mật khẩu mới của bạn',
      body: `Xin chào ${name},\n\nMật khẩu mới của bạn là: ${newPassword}\n\nVui lòng đăng nhập và đổi mật khẩu mới để đảm bảo an toàn cho tài khoản của bạn.\n\nFrom PetShop Team with love ❤️`
  };
}

function orderConfirmation(name, orderId) {
  return {
      subject: `Xác nhận đơn hàng #${orderId}`,
      body: `Xin chào ${name},\n\nChúng tôi đã nhận được đơn hàng của bạn (#${orderId}).\nCảm ơn bạn đã mua sắm tại PetShop!\n\nFrom PetShop Team with love ❤️`
  };
}

module.exports = { accountCreated, passwordReset, orderConfirmation };