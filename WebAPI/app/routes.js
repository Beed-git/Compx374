module.exports = app => {
	const artists = require("./controllers/artists.controller");
	const competitions = require("./controllers/competition.controller");
	const moderators = require("./controllers/moderators.controller");
	const media = require("./controllers/media.controller");
	const auth = require("./auth");

	// Main page.
	app.get("/", (req, res) => {
		res.json({ message: "Tuakiri" });
	});

	app.get("/authtest/", auth, (req, res) => {
		res.status(200).send("Auth success!");
	});

	app.get("/artists", artists.getArtistsQuery);
	app.get("/artists/:id", artists.getArtistById);

	app.get("/moderators", moderators.getModeratorsQuery);
	app.get("/moderators/:id", moderators.getModeratorById);

	app.get("/media", media.getMediaQuery);
	app.get("/media/:id", media.getMediaById);

	app.get("/competitions", competitions.getCompetitions);
	app.get("/competitions/:id", competitions.getCompetitionById);
}