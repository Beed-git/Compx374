const Competition = require("../models/competition.model");

const getCompetitions = async function(req, res) {
    try {
		if (req.query.location) {
			const current = await Competition.getCurrentCompetition(req.query.location);
			if (current != null) {
				res.status(200).json({ competition: current });
			} else {
				res.status(404).send("Location '" + req.query.location + "' does not exist.");
			}
		} else {
			const competitions = await Competition.getAllCompetitions();
        	res.status(200).json({ competitions: competitions });
		}
    } catch (err) {
        console.log(err);
        res.sendStatus(500);
    }
}

const getCompetitionById = async function(req, res) {
    if (!isNaN(req.params.id)) {
		try {
			const competition = await Competition.getCompetitionById(req.params.id);
			if (competition) {
				res.status(200).json({competition: competition});
			} else {
				res.status(404).send("Competition with id '" + req.params.id + "' does not exist.");
			}
		}
		catch (err) {
			console.log(err);
			res.sendStatus(500);
		}
	} else {
        console.log("Id is not a number.");
        res.sendStatus(500);
    }
}

const getCurrentCompetition = async function(req, res) {
    try {
        const competition = await Competition.getCurrentCompetition(req.query.location);
        res.status(200).json({ competition: competition });
    } catch (err) {
        console.log(err);
        res.sendStatus(500);
    }
}

module.exports = {
    getCompetitions,
    getCompetitionById,
    getCurrentCompetition,
}