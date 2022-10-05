const db = require("./db");
const util = require("util");

const query = util.promisify(db.query).bind(db);

const Media = function(row) {
    return {
        id: row.media_id,
        url: row.media_url,
        name: row.name,
        description: row.description,
        artist_id: row.artist_id,
        media_type: row.media_type,
    }
}

const getAllMedia = async function() {
    const res = await query("select * from Media");
    let media = [];
    res.forEach((row) => {
        media.push(Media(row));
    });
    return media;
}

const getMediaById = async function(id) {
    const res = await query("select * from Media where media_id = " + id);
    if (res.length > 0) {
        return Artist(res[0]);
    } else return null;
}

const getMediaByArtist = async function(id) {
    const res = await query("select * from Media where artist_id = " + id);
    let media = [];
    res.forEach((row) => {
        media.push(Media(row));
    });
    return media;
}

module.exports = {
    Media,
    getAllMedia,
    getMediaById,
    getMediaByArtist,
};