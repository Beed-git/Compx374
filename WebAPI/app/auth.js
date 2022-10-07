const jwt 	  = require("jsonwebtoken");
const config = require("./config/config");

const verifyToken = (req, res, next) => {

	const test = jwt.sign({ user_id: "test"}, config.TOKEN, {});
	console.log(test);


	const token = req.body.token || req.query.token || req.headers["x-access-token"];
	console.log(token);

	if (!token) {
		return res.status(403).send("This request requires an access token.");
	}
	try {
		const checked = jwt.verify(token, config.TOKEN);
		req.user = checked;
	} catch (err) {
		console.log(err);
		return res.status(500)
	}
	return next();
}

module.exports = verifyToken;