import React from 'react';
import ReactDOM from 'react-dom';
import {
    BrowserRouter as Router,
    Switch,
    Route,
    Link
} from "react-router-dom";

import Home from './pages/Home';
import Users from './components/Users';
import { createRoot } from 'react-dom/client';
const container = document.getElementById('app');
const root = createRoot(container); // createRoot(container!) if you use TypeScript

function Main() {
    return (
        <div>
            <Users />
        </div>
    );
}

export default Main;

if (document.getElementById('app')) {
    root.render(<Main />);
}