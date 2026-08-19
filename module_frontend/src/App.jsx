import { HashRouter as Router, Routes, Route } from 'react-router-dom'
import {lazy} from "react";
import Layout from "./components/Layout.jsx";
import Panel from "./components/Panel.jsx";

const Home = lazy(() => import('./pages/Home'));
const Reading = lazy(() => import('./pages/Reading'));
const Search = lazy(() => import('./pages/Search'));
const NotFound = lazy(() => import('./pages/NotFound'));
const Bookmarks = lazy(() => import('./pages/Bookmarks'));

function App() {
  return (
    <Router>
        <Layout>
            <Routes>
                <Route path="/" element={<Home />} />
                <Route path="/chapter/:chapterId/section/:sectionId" element={<Reading />} />
                <Route path="/search/:query" element={<Search />} />
                <Route path="/bookmarks" element={<Bookmarks />} />

                <Route path={'*'} element={<NotFound />} />
            </Routes>
            <Panel/>
        </Layout>
    </Router>
  )
}

export default App
