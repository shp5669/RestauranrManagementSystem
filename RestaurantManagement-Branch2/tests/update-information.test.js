// const chai = require('chai');
// const expect = chai.expect;
// const request = require('supertest');
// const app = require('../Back-end/app'); // Replace with the path to your Express app
// describe('POST /update-information', () => {
//     it('should update user information when valid data is provided', (done) => {
//         // this.timeout(5000);
//         const userData = {
//             email: 'test@example.com',
//             phone: '1232',
//             name: 'John Doe',
//             cardNumber: '1234 5678 1234 5678',
//             address: '123 Main St'
//         };
//         request(app)
//             .post('/api/accounts/update-information')
//             .send(userData)
//             .expect(200)
//             .then(res => {
//                 expect(res.body).to.have.property('message').that.equals('Update successfully');
//               })
//             .catch(err=>console.log(err))
//             // .end((err, res) => {
//             //     if (err) return done(err);
//             //     // You can add additional assertions here
//             //     expect(res.body).to.have.property('message').that.equals('Update successfully');
//             //     // expect(res.body).to.have.property('message').to.equal('Update successfully');
//             //     done();
//             // });
//     });
// });

// const chai = require('chai');
// const expect = chai.expect;
// const request = require('supertest');
// const app = require('../Back-end/app');

// describe('POST /update-information', () => {
//     this.timeout(10000);
//     it('should update user information when valid data is provided', async () => {
//         const userData = {
//             email: 'test@example.com',
//             phone: '1232',
//             name: 'John Doe',
//             cardNumber: '1234 5678 1234 5678',
//             address: '123 Main St'
//         };

//         const response = await request(app)
//             .post('/api/accounts/update-information')
//             .send(userData)
//             .expect(200);

//         expect(response.body.message).to.equal('Update successfully');
//     });
// });
const chai = require('chai');
const expect = chai.expect;
const request = require('supertest');
const app = require('../Back-end/app');

describe('POST /update-information', () => {
    it('should update user information when valid data is provided', function(done) {
        this.timeout(10000); // Set a timeout of 10 seconds for this test
        const userData = {
            email: 'test@example.com',
            phone: '1232',
            name: 'John Doe',
            cardNumber: '1234 5678 1234 5678',
            address: '123 Main St'
        };
        request(app)
            .post('/api/accounts/update-information')
            .send(userData)
            .expect(200)
            .then(res => {
                expect(res.body.message).to.equal('Update successfully');
                done(); // Call done() to signal that the test is complete
            })
            .catch(err => {
                done(err); // If there's an error, pass it to done()
            });
    });
});
