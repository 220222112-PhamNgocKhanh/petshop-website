function authorizeRole(...allowedRoles) {
    return (req, res, next) => {
        const userRole = req.user?.role;
        if (!allowedRoles.includes(userRole)) {
            res.writeHead(403, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'Access denied: insufficient permissions' }));
        }
        next();
    };
}

module.exports = authorizeRole;
