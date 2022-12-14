const Media = require("../models/media.model");

const getMediaQuery = async function(req, res) {
    if (req.query.artist_id) {
        await getMediaByArtist(req, res, req.query.artist_id);
    } else if (req.query.display_id) {
        await getMediaByDisplay(req, res, req.query.display_id);
    } else {
        getMedia(req, res);
    }
}

const getMedia = async function(req, res) {
    try {
        const media = await Media.getAllMedia();
        res.status(200).json({ media: media });
    } catch (err) {
        console.log(err);
        res.sendStatus(500);
    }
}

const getMediaById = async function(req, res) {
    if (!isNaN(req.params.id)) {
		try {
			const media = await Media.getMediaById(req.params.id);
			if (media) {
				res.status(200).json({media: media});
			} else {
				res.status(404).send("Media with id '" + req.params.id + "' does not exist.");
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

const getMediaByArtist = async function (req, res, artist_id) {
    if (!isNaN(artist_id)) {
        try {
            const media = await Media.getMediaByArtist(artist_id);
            res.status(200).json({ media: media });
        } catch (err) {
            console.log(err);
            res.sendStatus(500);
        }
    }
}

const getMediaByDisplay = async function (req, res, display_id) {
    if (!isNaN(display_id)) {
        try {
            const media = await Media.getMediaByDisplay(display_id);
            res.status(200).json({media: media});
        } catch (err) {
            console.log(err);
            res.sendStatus(500);
        }
    }
}

module.exports = {
    getMediaById,
    getMediaQuery,
}