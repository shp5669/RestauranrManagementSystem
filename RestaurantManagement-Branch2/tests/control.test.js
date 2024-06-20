const fs = require('fs');
const path = require('path');
const jsdom = require('jsdom');
const { JSDOM } = jsdom;

const controlScript = fs.readFileSync(path.resolve(__dirname, '../control.js'), 'utf8');

beforeEach(() => {
  const dom = new JSDOM('<!doctype html><html><body><form id="myform"><input id="email" /><input id="password" /></form></body></html>');
  global.document = dom.window.document;
  global.window = dom.window;
  eval(controlScript);
});

test('Form submission should work', async () => {
  const form = document.getElementById('myform');
  const emailInput = document.getElementById('email');
  const passwordInput = document.getElementById('password');

  emailInput.value = 'test@example.com';
  passwordInput.value = 'password123';

  const mockResponse = { message: 'Data successfully sent' };
  global.fetch = jest.fn(() => Promise.resolve({
    json: () => Promise.resolve(mockResponse),
  }));

  const event = new global.window.Event('submit');
  form.dispatchEvent(event);

  // Assertions
  expect(global.fetch).toHaveBeenCalledWith('http://localhost:3000/api/accounts', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      email: 'test@example.com',
      password: 'password123',
    }),
  });

  // You can also assert if the console.log was called with the expected output
  expect(console.log).toHaveBeenCalledWith(mockResponse);
});

// Add more test cases as needed
