import React from 'react';
import { createRoot } from 'react-dom/client';
const container = document.getElementById('app');
const root = createRoot(container); // createRoot(container!) if you use TypeScript
import Home from './pages/Home'

function Main() {
    return (
        <div>
            <Home />
        </div>
    );
}

export default Main;

if (document.getElementById('app')) {
    root.render(<Main />);
}