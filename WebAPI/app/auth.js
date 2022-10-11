const jwt = require("jsonwebtoken");
const config = require("./config/config");

const verifyToken = (req, res, next) => {
	const token = req.body.token || req.query.token || req.headers["x-access-token"];

	if (!token) {
		return res.status(403).send("This request requires an access token.");
	}
	try {
		const checked = jwt.verify(token, config.TOKEN);
		req.user = checked;
	} catch (err) {
		console.log(err);
		return res.status(500).send("Failed to verify token.");
	}
	
	return next();
}

const genToken = (location) => {
	const token = jwt.sign({ location: location }, config.TOKEN, {});
	return token;
}

module.exports = {
	verifyToken,
	genToken,
}