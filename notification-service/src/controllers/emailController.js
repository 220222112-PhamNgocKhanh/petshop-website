const { sendEmail } = require('../utils/mailer');
const templates = require('../utils/emailTemplates');

async function sendEmailHandler(data, res) {
  const { type, to, name, orderId, link } = data;

  let email = null;

  switch (type) {
    case 'accountCreated':
      email = templates.accountCreated(name);
      break;
    case 'passwordReset':
      email = templates.passwordReset(name, link);
      break;
    case 'orderConfirmation':
      email = templates.orderConfirmation(name, orderId);
      break;
    default:
      res.writeHead(400, { 'Content-Type': 'application/json' });
      res.end(JSON.stringify({ error: 'Invalid email type' }));
      return;
  }

  try {
    await sendEmail(to, email.subject, email.body);
    res.writeHead(200, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify({ message: 'Email sent successfully' }));
  } catch (err) {
    console.error('[ERROR] Send email failed:', err.message);
    res.writeHead(500, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify({ error: 'Failed to send email' }));
  }
}

module.exports = { sendEmailHandler };