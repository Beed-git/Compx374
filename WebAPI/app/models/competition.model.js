const db = require("./db");
const util = require("util");

const query = util.promisify(db.query).bind(db);

const Competition = function(row) {
    return {
        id: row.competition_id,
        name: row.name,
        description: row.description,
    }
}

const getAllCompetitions = async function() {
    const res = await query("select * from Competition");
    let competitions = [];
    res.forEach((row) => {
        competitions.push(Competition(row));
    });
    return competitions;
}

const getCompetitionById = async function(id) {
    const res = await query("select * from Competition where competition_id = " + id);
    if (res.length > 0) {
        return Competition(res[0]);
    } else return null;
}

module.exports = {
    Competition,
    getAllCompetitions,
    getCompetitionById,
};