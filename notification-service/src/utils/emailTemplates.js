function accountCreated(name) {
    return {
      subject: 'Chào mừng bạn đến với PetShop!',
      body: `Xin chào ${name},\n\nTài khoản của bạn đã được tạo thành công. Cảm ơn bạn đã đăng ký!\n\nPetShop Team`,
    };
  }
  
  function passwordReset(name, link) {
    return {
      subject: 'Yêu cầu đặt lại mật khẩu',
      body: `Xin chào ${name},\n\nChúng tôi nhận được yêu cầu đặt lại mật khẩu của bạn.\nBấm vào liên kết sau để tiếp tục: ${link}\n\nPetShop Team`,
    };
  }
  
  function orderConfirmation(name, orderId) {
    return {
      subject: `Xác nhận đơn hàng #${orderId}`,
      body: `Xin chào ${name},\n\nChúng tôi đã nhận được đơn hàng của bạn (#${orderId}).\nCảm ơn bạn đã mua sắm tại PetShop!\n\nPetShop Team`,
    };
  }
  
  module.exports = {
    accountCreated,
    passwordReset,
    orderConfirmation,
  };
  