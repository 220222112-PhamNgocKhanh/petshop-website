const http = require('http');
const url = require('url');

// Dữ liệu giả lập người dùng
let users = [
  { id: 1, name: 'John Doe', email: 'john.doe@example.com' },
  { id: 2, name: 'Jane Doe', email: 'khanh@gmail.com' }
];

// Hàm xử lý API lấy tất cả người dùng
function getAllUsers(req, res) {
  res.writeHead(200, { 'Content-Type': 'application/json' });
  res.end(JSON.stringify(users));
}

// Hàm xử lý API lấy thông tin người dùng theo ID
function getUserById(req, res, userId) {
  const user = users.find(u => u.id === parseInt(userId));
  if (user) {
    res.writeHead(200, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify(user));
  } else {
    res.writeHead(404, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify({ error: 'User not found' }));
  }
}

// Hàm xử lý API đăng nhập
function loginUser(req, res) {
  let body = '';
  req.on('data', chunk => {
    body += chunk.toString();
  });
  req.on('end', () => {
    const { email } = JSON.parse(body);
    const user = users.find(u => u.email === email);
    if (user) {
      res.writeHead(200, { 'Content-Type': 'application/json' });
      res.end(JSON.stringify({ message: 'Login successful', user }));
    } else {
      res.writeHead(401, { 'Content-Type': 'application/json' });
      res.end(JSON.stringify({ error: 'Invalid email or password' }));
    }
  });
}

// Tạo server HTTP cho User Service
const server = http.createServer((req, res) => {
  const parsedUrl = url.parse(req.url, true);

  if (parsedUrl.pathname === '/users' && req.method === 'GET') {
    // API lấy tất cả người dùng
    getAllUsers(req, res);
  } else if (parsedUrl.pathname.match(/\/user\/(\d+)/) && req.method === 'GET') {
    // API lấy thông tin người dùng theo ID
    const userId = parsedUrl.pathname.split('/')[2];
    getUserById(req, res, userId);
  } else if (parsedUrl.pathname === '/login' && req.method === 'POST') {
    // API đăng nhập
    loginUser(req, res);
  } else {
    // Xử lý các yêu cầu không hợp lệ
    res.writeHead(404, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify({ error: 'Not found' }));
  }
});

// Khởi chạy User Service
server.listen(3001, () => {
  console.log('User Service is running on http://localhost:3001');
});