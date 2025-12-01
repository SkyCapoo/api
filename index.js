const express = require('express');
const app = express();
const port = process.env.PORT || 3000;


app.get('/', (req, res) => {
  res.json({ message: 'Hello from Render API! 部署成功～' });
});

app.listen(port, () => {
  console.log(`API running on port ${port}`);
});