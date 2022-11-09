const db = require("./db");
const util = require("util");

const query = util.promisify(db.query).bind(db);

const Artist = function(row) {
    return {
        id: row.artist_id,
        email: row.email,
        username: row.username,
        password: row.password,
        story: row.story,
    }
}

const getAllArtists = async function() {
    const res = await query("select * from Artist");
    let artists = [];
    res.forEach((row) => {
        artists.push(Artist(row));
    });
    return artists;
}

const getArtistById = async function(id) {
    const res = await query("select * from Artist where artist_id = " + db.escape(id));
    if (res.length > 0) {
        return Artist(res[0]);
    } else return null;
}

const getArtistByUsername = async function(username) {
    const res = await query("select * from Artist where username = " + db.escape(username));
    if (res.length > 0) {
        return Artist(res[0]);
    } else return null;
}

const getArtistByEmail = async function(email) {
    const res = await query("select * from Artist where email = " + db.escape(email));
    if (res.length > 0) {
        return Artist(res[0]);
    } else return null;
}

const createArtist = async function(artist) {
    const res = await query (db.format("insert into Artist(email, username, password) values (?, ?, ?)", [artist.email, artist.username, artist.password]));
    return res.insertId;
}

module.exports = {
    Artist,
    createArtist,
    getAllArtists,
    getArtistById,
    getArtistByUsername,
    getArtistByEmail,
};