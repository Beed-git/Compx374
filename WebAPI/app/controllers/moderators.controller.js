const Moderator = require("../models/moderator.model");

const getModeratorsQuery = async function(req, res) {
    if (req.query.name) {
        await getModeratorByUsername(req, res, req.query.name);
    } else if (req.query.email) {
        await getModeratorByEmail(req, res, req.query.email);    
    } else {
        getModerators(req, res);
    }
}

const getModerators = async function(req, res) {
    try {
        const moderators = await Moderator.getAllModerators();
        res.status(200).json({ moderators: moderators });
    } catch (err) {
        console.log(err);
        res.sendStatus(500);
    }
}

const getModeratorById = async function(req, res) {
    if (!isNaN(req.params.id)) {
		try {
			const moderator = await Moderator.getModeratorById(req.params.id);
			if (moderator) {
				res.status(200).json({moderator: moderator});
			} else {
				res.status(404).send("Moderator with id '" + req.params.id + "' does not exist.");
			}
		}
		catch (err) {
			console.log(err);
			res.sendStatus(500);
		}
	}
}

const getModeratorByUsername = async function(req, res, name) {
	try {
		const moderator = await Moderator.getModeratorByUsername(name);
		if (moderator) {
			res.status(200).json({moderator: moderator})
		} else {
			res.status(404).send("Moderator with name '" + name + "' does not exist.");
		}
	} catch (err) {
		console.log(err);
		res.sendStatus(500);
	}
}

const getModeratorByEmail = async function(req, res, email) {
	try {
		const moderator = await Moderator.getModeratorByEmail(email);
		if (moderator) {
			res.status(200).json({moderator: moderator})
		} else {
			res.status(404).send("Moderator with email '" + email + "' does not exist.");
		}
	} catch (err) {
		console.log(err);
		res.sendStatus(500);
	}
}

module.exports = {
    getModerators,
    getModeratorById,
    getModeratorsQuery,
}