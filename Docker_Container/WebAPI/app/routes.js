module.exports = app => {
	const artists = require("./controllers/artists.controller");
	const competitions = require("./controllers/competition.controller");
	const displays = require("./controllers/display.controller");
	const moderators = require("./controllers/moderators.controller");
	const media = require("./controllers/media.controller");
	const mediaInstance = require("./controllers/media_instance.controller");

	const auth = require("./auth");

	const args = process.argv.slice(2);
	for (let i = 0; i < args.length; i++) {
		const arg = args[i];
		if (arg == "--gen-token") {
			i++;
			if (i < args.length) {
				const location = args[i];
				const token = auth.genToken(location);
				console.log("Generated token for '" + location + "': " + token);
			} else {
				console.log("Please provide a location to generate the token for.");
			}
		}
	}

	// Main page.
	app.get("/", (req, res) => {
		res.json({ message: "Tuakiri" });
	});

	app.get("/artists", auth.verifyToken, artists.getArtistsQuery);
	app.get("/artists/:id", auth.verifyToken, artists.getArtistById);

	app.get("/moderators", auth.verifyToken, moderators.getModeratorsQuery);
	app.get("/moderators/:id", auth.verifyToken, moderators.getModeratorById);

	app.get("/media", auth.verifyToken, media.getMediaQuery);
	app.get("/media/:id", auth.verifyToken, media.getMediaById);

	app.get("/competitions", auth.verifyToken, competitions.getCompetitions);
	app.get("/competitions/:id", auth.verifyToken, competitions.getCompetitionById);

	app.get("/displays", auth.verifyToken, displays.getDisplayQuery);
	app.get("/displays/:id", auth.verifyToken, displays.getDisplayById);

	app.get("/media_instances", auth.verifyToken, mediaInstance.getMediaInstanceQuery);
	app.get("/media_instances/:id", auth.verifyToken, mediaInstance.getMediaInstanceById);
}