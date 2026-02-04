const QRCode = require('qrcode');

function createSession({ sessionId, tenantId, label }) {
  return {
    sessionId,
    tenantId,
    label,
    status: 'pending_qr',
    createdAt: new Date().toISOString(),
  };
}

function getSession(store, sessionId) {
  return store.get(sessionId);
}

async function buildQrPayload(session) {
  const payload = `wa-gateway:${session.sessionId}:${session.tenantId}`;
  return QRCode.toDataURL(payload);
}

async function sendMessage(session, { to, message }) {
  return {
    session_id: session.sessionId,
    to,
    message,
    status: 'queued',
    provider: 'whatsapp-web',
  };
}

module.exports = {
  buildQrPayload,
  createSession,
  getSession,
  sendMessage,
};
