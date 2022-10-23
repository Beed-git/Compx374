const MediaInstance = require("../models/media_instance.model")

const getMediaInstanceQuery = async function(req, res) {
    if (req.query.display) {
        await getMediaInstanceByDisplay(req, res, req.query.display);
    } else {
        getMediaInstances(req, res);
    }
}

const getMediaInstances = async function(req, res) {
    try {
        const instances = await MediaInstance.getAllMediaInstances();
        res.status(200).json({ media_instances: instances });
    } catch (err) {
        console.log(err);
        res.sendStatus(500);
    }
}

const getMediaInstanceByDisplay = async function(req, res, id) {
    if (!isNaN(id)) {
		try {
			const instance = await MediaInstance.getMediaInstanceByDisplay(id);
			if (instance) {
				res.status(200).json({media_instance: instance});
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
		res.status(404).send("'" + id + "' is not a number.");
	}
}

const getMediaInstanceById = async function(req, res) {
    if (!isNaN(req.params.id)) {
		try {
			const instance = await MediaInstance.getMediaInstanceById(req.params.id);
			if (instance) {
				res.status(200).json({media_instance: instance});
			} else {
				res.status(404).send("Media Instance with id '" + req.params.id + "' does not exist.");
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
    getMediaInstanceQuery,
    getMediaInstanceById,
}