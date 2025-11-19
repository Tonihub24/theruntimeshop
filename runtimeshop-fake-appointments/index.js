// index.js
console.log("📌 index.js has started...");
require('dotenv').config();
const express = require('express');
const bodyParser = require('body-parser');
const MessagingResponse = require('twilio').twiml.MessagingResponse;

const app = express();
app.use(bodyParser.urlencoded({ extended: false }));

// Handle incoming SMS
app.post('/sms', (req, res) => {
  const incomingMsg = req.body.Body;
  console.log(`📩 Received: ${incomingMsg}`);

  // Basic time/date detection — you can improve with NLP later
  const fakeReply = `✅ FullyBooked appointment scheduled: "${incomingMsg}". You’re all set.`;

  const twiml = new MessagingResponse();
  twiml.message(fakeReply);

  res.writeHead(200, { 'Content-Type': 'text/xml' });
  res.end(twiml.toString());
});

// Start server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`🚀 SMS fake appointment app listening on port ${PORT}`);
});
