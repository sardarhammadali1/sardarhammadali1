const express = require('express');
const { v4: uuidv4 } = require('uuid');
const { buildQrPayload, createSession, getSession, sendMessage } = require('./whatsapp');

const app = express();
app.use(express.json());

const sessions = new Map();

app.post('/sessions', async (req, res) => {
  const { tenant_id: tenantId, label } = req.body;
  if (!tenantId || !label) {
    return res.status(422).json({ error: 'tenant_id and label are required' });
  }

  const sessionId = uuidv4();
  const session = createSession({ sessionId, tenantId, label });
  sessions.set(sessionId, session);

  return res.status(201).json({
    data: {
      session_id: sessionId,
      status: session.status,
      label: session.label,
    }
  });
});

app.get('/sessions/:sessionId/qr', async (req, res) => {
  const { sessionId } = req.params;
  const session = getSession(sessions, sessionId);
  if (!session) {
    return res.status(404).json({ error: 'Session not found' });
  }

  const qr = await buildQrPayload(session);
  return res.json({
    data: {
      session_id: sessionId,
      qr,
    }
  });
});

app.post('/messages', async (req, res) => {
  const { session_id: sessionId, to, message } = req.body;
  const session = getSession(sessions, sessionId);
  if (!session) {
    return res.status(404).json({ error: 'Session not found' });
  }
  if (!to || !message) {
    return res.status(422).json({ error: 'to and message are required' });
  }

  const delivery = await sendMessage(session, { to, message });

  return res.json({
    data: delivery,
  });
});

const port = process.env.PORT || 3001;
app.listen(port, () => {
  console.log(`WhatsApp gateway listening on ${port}`);
});
