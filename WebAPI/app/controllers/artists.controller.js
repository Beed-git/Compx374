const Artist = require("../models/artist.model");

const getArtistsQuery = async function(req, res) {
    if (req.query.name) {
        await getArtistByUsername(req, res, req.query.name);
    } else if (req.query.email) {
        await getArtistByEmail(req, res, req.query.email);    
    } else {
        getArtists(req, res);
    }
}

const getArtists = async function(req, res) {
    try {
        const artists = await Artist.getAllArtists();
        res.status(200).json({ artists: artists });
    } catch (err) {
        console.log(err);
        res.sendStatus(500);
    }
}

const getArtistById = async function(req, res) {
    if (!isNaN(req.params.id)) {
		try {
			const artist = await Artist.getArtistById(req.params.id);
			if (artist) {
				res.status(200).json({artist: artist});
			} else {
				res.status(404).send("Artist with id '" + req.params.id + "' does not exist.");
			}
		}
		catch (err) {
			console.log(err);
			res.sendStatus(500);
		}
	}
}

const getArtistByUsername = async function(req, res, name) {
	try {
		const artist = await Artist.getArtistByUsername(name);
		if (artist) {
			res.status(200).json({artist: artist})
		} else {
			res.status(404).send("Artist with name '" + name + "' does not exist.");
		}
	} catch (err) {
		console.log(err);
		res.sendStatus(500);
	}
}

const getArtistByEmail = async function(req, res, email) {
	try {
		const artist = await Artist.getArtistByEmail(email);
		if (artist) {
			res.status(200).json({artist: artist})
		} else {
			res.status(404).send("Artist with email '" + email + "' does not exist.");
		}
	} catch (err) {
		console.log(err);
		res.sendStatus(500);
	}
}

module.exports = {
    getArtists,
    getArtistById,
    getArtistsQuery,
}