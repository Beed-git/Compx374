const db = require("./db");
const util = require("util");

const query = util.promisify(db.query).bind(db);

const Display = function(row) {
    return {
        id: row.display_id,
        name: row.name,
        description: row.description,
        moderator_id: row.moderator_id,
        competition_id: row.competition_id,
    }
}

const getAllDisplays = async function() {
    const res = await query("select * from Display");
    let displays = [];
    res.forEach((row) => {
        displays.push(Display(row));
    });
    return displays;
}

const getDisplayById = async function(id) {
    const res = await query("select * from Display where display_id = " + db.escape(id));
    if (res.length > 0) {
        return Display(res[0]);
    } else return null;
}

const getDisplaysByCompetition = async function(id) {
    const res = await query("select * from Display where competition_id = " + db.escape(id));
    let displays = [];
    res.forEach((row) => {
        displays.push(Display(row));
    });
    return displays;
}

module.exports = {
    Display,
    getAllDisplays,
    getDisplayById,
    getDisplaysByCompetition,
};