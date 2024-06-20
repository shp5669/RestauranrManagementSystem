const { response } = require("express");
const express = require("express");
const menuItem = require("../models/menuItem");
const router = express.Router();

router.post("/create",(req,res,next) => {
    const {name, category} = req.body;
    const menuItem = new menuItem({
        name : name,
        category : category,
    })
    menuItem.save().then(result => {
        res.status(200).json({
        })
    })
})
