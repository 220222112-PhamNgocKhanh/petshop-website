const nodemailer = require('nodemailer');

const transporter = nodemailer.createTransport({
  service: 'gmail',
  auth: {
    user: process.env.EMAIL_USER,
    pass: process.env.EMAIL_PASS,
  },
});

function sendEmail(to, subject, body) {
  const mailOptions = {
    from: process.env.EMAIL_USER,
    to,
    subject,
    text: body,
  };

  return transporter.sendMail(mailOptions);
}
console.log('SMTP Config:', {
    host: process.env.SMTP_HOST,
    port: process.env.SMTP_PORT,
    user: process.env.SMTP_USER,
});
module.exports = { sendEmail };
