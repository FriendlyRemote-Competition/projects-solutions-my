import { createRoot } from 'react-dom/client'
import "./bootstrap/css/bootstrap.min.css"
import './index.css'
import App from './App.jsx'
import {StoreProvider} from "./store.jsx";

createRoot(document.getElementById('root')).render(
    <StoreProvider>
        <App />
    </StoreProvider>
)
