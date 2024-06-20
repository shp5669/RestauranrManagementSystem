const { response } = require("express");
const express = require("express");
const account = require("../models/account");
const Account = require("../models/account");
const nodemailer = require("nodemailer");
const router = express.Router();
const transporter = nodemailer.createTransport({
    service: "gmail",
    auth: {
      user: "lamtiensinh2301@gmail.com",
      pass: "vjbquihufkduwzkg",
    },
  });
router.post("", (req,res,next)=>{
    const {email, password} = req.body;
    Account.findOne({email,password}).then(userValid=>{
        if(userValid){
            res.status(200).send(userValid);
        }
    });
})
router.post("/resetpassword",(req,res,next) => {
    const {email, password} = req.body;
    Account.updateOne({ email }, { $set: { password: password } }).then(() => {
        res.status(200).json({
            message:"Update Successfully"
        })
    }).catch(err => console.log(err))
})
router.post("/create",(req,res,next) => {
    const {email, password} = req.body;
    console.log(req.body)
    const account = new Account({
        email : email,
        password : password,
    })
    account.save().then(result => {
        const mailOptions = {
            from: "lamtiensinh2301@gmail.com",
            to: email,
            subject: "Welcome to Group8's Restaurant",
            text: `Hi, Thank you for signing up`,
          };
        transporter.sendMail(mailOptions);
        res.status(200).json({
            message:"Create account successfully"
        })
    })
})
router.post("/update-information",(req,res,next) => {
    const {phone, name, cardNumber, address, DOB} = req.body;
    console.log(req.body)
    // Account.findOneAndUpdate({email: req.body.email}, req.body).then(response => {
    //     res.status(200).send({ message: "Update successfully" });
    // }).catch(err => {
    //     res.status(400).send(err)
    // })
    console.log('Request Body:', req.body); // Log the request body
    Account.findOneAndUpdate({ email: req.body.email }, req.body)
        .then(response => {
            console.log('Database Response:', response);
            res.status(200).send({ message: "Update successfully" });
        })
        .catch(err => {
            console.log('Database Error:', err);
            res.status(400).send(err);
        });
    
})
router.post("/get-data", (req,res,next) => {
    Account.findOne({email: req.body.email}).then(response => {
        res.status(200).send(response)
    }).catch(err => {
        res.status(400).send(err)
    })
})
router.post("/delete", (req,res,next) => {
    Account.deleteOne({email: req.body.email}).then(response => {
        res.status(200).send(response)
    }).catch(err => {
        res.status(400).send(err)
    })
})
module.exports = router;
