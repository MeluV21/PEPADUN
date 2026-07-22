const { Client, LocalAuth } = require('whatsapp-web.js');
const qrcode = require('qrcode-terminal');
const express = require('express');

const app = express();
app.use(express.json()); // Allow JSON body parsing

// Initialize WhatsApp Client
// LocalAuth saves session so you don't need to scan QR code on every restart
const client = new Client({
    authStrategy: new LocalAuth(),
    puppeteer: { 
        headless: true,
        args: ['--no-sandbox', '--disable-setuid-sandbox'] // helpful for stability in some environments
    }
});

// Event when QR code needs to be scanned
client.on('qr', (qr) => {
    console.log('\n=========================================');
    console.log('SCAN THIS QR CODE WITH YOUR WHATSAPP');
    console.log('=========================================\n');
    qrcode.generate(qr, { small: true });
});

// Event when successfully authenticated
client.on('ready', () => {
    console.log('WhatsApp Client is ready!');
});

// Start initialization
client.initialize();

// ==========================================
// API ENDPOINT FOR CODEIGNITER TO CALL
// ==========================================
app.post('/send-message', async (req, res) => {
    try {
        const number = req.body.number; // Target number
        const message = req.body.message; // Message content

        if (!number || !message) {
            return res.status(400).json({ status: false, message: 'Number and message are required' });
        }

        // Format number to standard WhatsApp format (append @c.us)
        let formattedNumber = number;
        // Convert starting 0 to 62
        if (formattedNumber.startsWith('0')) {
            formattedNumber = '62' + formattedNumber.substring(1);
        }
        // Remove spaces or dashes if any
        formattedNumber = formattedNumber.replace(/[\s-]/g, '');
        
        const chatId = formattedNumber + '@c.us';

        // Send the message
        await client.sendMessage(chatId, message);
        
        console.log(`Message successfully sent to ${number}`);
        res.json({ status: true, message: 'Pesan berhasil dikirim' });
    } catch (error) {
        console.error('Error sending message:', error);
        res.status(500).json({ status: false, message: 'Gagal mengirim pesan', error: error.toString() });
    }
});

// Start the Express server
const PORT = 3000;
app.listen(PORT, () => {
    console.log(`\n=========================================`);
    console.log(`Local WhatsApp API Server is running on http://localhost:${PORT}`);
    console.log(`=========================================\n`);
});
