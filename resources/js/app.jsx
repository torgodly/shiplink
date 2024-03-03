// app.jsx
import React from 'react'; // Import React
import './bootstrap';
import {createRoot} from 'react-dom/client';

// window.createRoot = createRoot;
import App from './AppS.jsx';

const domNode = document.getElementById('app');
const root = createRoot(domNode);
root.render(
    <React.StrictMode>
        <App/>
    </React.StrictMode>,
);
