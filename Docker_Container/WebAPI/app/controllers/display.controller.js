const Display = require("../models/display.model");

const getDisplayQuery = async function(req, res) {
    if (req.query.competition) {
        await getDisplayByCompetition(req, res, req.query.competition);
    } else {
        getDisplays(req, res);
    }
}

const getDisplays = async function(req, res) {
    try {
        const displays = await Display.getAllDisplays();
        res.status(200).json({ displays: displays });
    } catch (err) {
        console.log(err);
        res.sendStatus(500);
    }
}

const getDisplayById = async function(req, res) {
    if (!isNaN(req.params.id)) {
		try {
			const display = await Display.getDisplayById(req.params.id);
			if (display) {
				res.status(200).json({display: display});
			} else {
				res.status(404).send("Display with id '" + req.params.id + "' does not exist.");
			}
		}
		catch (err) {
			console.log(err);
			res.sendStatus(500);
		}
	}
	else {
		res.status(404).send("'" + req.params.id + "' is not a number.");
	}
}

const getDisplayByCompetition = async function(req, res, id) {
    if (!isNaN(id)) {
		try {
			const display = await Display.getDisplaysByCompetition(id);
			if (display) {
				res.status(200).json({display: display});
			} else {
				res.status(404).send("Display with id '" + id + "' does not exist.");
			}
		}
		catch (err) {
			console.log(err);
			res.sendStatus(500);
		}
	}
	else {
		res.status(404).send("'" + req.params.id + "' is not a number.");
	}
}

module.exports = {
    getDisplayQuery,
    getDisplayById,
}