const db = require("./db");
const util = require("util");

const query = util.promisify(db.query).bind(db);

const Moderator = function(row) {
    return {
        id: row.moderator_id,
        email: row.email,
        username: row.username,
        password: row.password,
    };
}

const getAllModerators = async function() {
    const res = await query("select * from Moderator");
    let moderators = [];
    res.forEach((row) => {
        moderators.push(Moderator(row));
    });
    return moderators;
}

const getModeratorById = async function(id) {
    const res = await query("select * from Moderator where moderator_id = " + db.escape(id));
    if (res.length > 0) {
        return Moderator(res[0]);
    } else return null;
}

const getModeratorByUsername = async function(username) {
    const res = await query("select * from Moderator where username = " + db.escape(username));
    if (res.length > 0) {
        return Moderator(res[0]);
    } else return null;
}

const getModeratorByEmail = async function(email) {
    const res = await query("select * from Moderator where email = " + db.escape(email));
    if (res.length > 0) {
        return Moderator(res[0]);
    } else return null;
}

module.exports = {
    Moderator,
    getAllModerators,
    getModeratorById,
    getModeratorByEmail,
    getModeratorByUsername
}