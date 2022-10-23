const db = require("./db");
const util = require("util");

const query = util.promisify(db.query).bind(db);

const MediaInstance = function(row) {
    return {
        id: row.minstance_id,
        x: row.x,
        y: row.y,
        z: row.z,
        scale_x: row.scale_x,
        scale_y: row.scale_y,
        scale_z: row.scale_z,
        media_id: row.media_id,
        video_id: row.video_id,
    }
}

const getAllMediaInstances = async function() {
    const res = await query("select * from Media_Instance");
    let instances = [];
    res.forEach((row) => {
        instances.push(MediaInstance(row));
    });
    return instances;
}

const getMediaInstanceById = async function(id) {
    const res = await query("select * from Media_Instance where minstance_id = " + db.escape(id));
    if (res.length > 0) {
        return MediaInstance(res[0]);
    } else return null;
}

const getMediaInstanceByDisplay = async function(id) {
    const res = await query("select * from Display_Contains d, Media_Instance m where d.minstance_id = m.minstance_id and d.display_id = " + db.escape(id));
    let instances = [];
    res.forEach((row) => {
        instances.push(MediaInstance(row));
    });
    return instances;
}

module.exports = {
    MediaInstance,
    getAllMediaInstances,
    getMediaInstanceById,
    getMediaInstanceByDisplay,
}