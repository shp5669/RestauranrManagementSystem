const mongoose = require("mongoose");

const menuItemSchema = mongoose.Schema({
    name: {type:String},
	cateogry:{type: String}
})

module.exports = mongoose.model("menu", menuItemSchema);