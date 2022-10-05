module.exports = app => {
  const artists = require("./controllers/artists.controller");
  const competitions = require("./controllers/competition.controller");
  const moderators = require("./controllers/moderators.controller");
  const media = require("./controllers/media.controller")

  // Main page.
	app.get("/", (req, res) => {
		res.json({ message: "Tuakiri" });
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