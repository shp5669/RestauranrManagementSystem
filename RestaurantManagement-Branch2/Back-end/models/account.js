const mongoose = require("mongoose");

const accountSchema = mongoose.Schema({
  email: { type: String },
  password: { type: String },
  phone: { type: String },
  name: { type: String },
  cardNumber: { type: String },
  address: { type: String },
  DOB: { type: Date },
});

module.exports = mongoose.model("Account", accountSchema);
