import React from 'react';

import {
  BrowserRouter as Router,
  useRoutes,
} from "react-router-dom";

import ListPrizeDraw from './pages/ListPrizeDraw/ListPrizeDraw'
import Draw from './pages/Draw/Draw';


const App = () => {
    let routes = useRoutes([
      { path: "/", element: <ListPrizeDraw /> },
      { path: "/draw", element: <Draw /> },
    ]);
    return routes;
  };
  

export default function RouterIndex(){
    return(
       
        <Router>
            <App />
        </Router>
    )
}