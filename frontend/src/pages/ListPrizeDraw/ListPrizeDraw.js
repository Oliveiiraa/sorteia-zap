import React, { useEffect, useState } from 'react';
import Header from '../../components/Header/Header'
import PrizeDraw from '../../components/PrizeDraw/prizeDraw';

import api from '../../services/api';

export default function ListPrizeDraw(){
    const [draws, setDraws] = useState([]);

    const listDraw = async () => {
        const response = await api.get(`/draw`);
        if(response.status === 200){
          setDraws(response.data)  
        }
        
      }

    useEffect(() => {
        listDraw();
    }, [])
    
    
    return (
        <>
       <Header title="List PrizeDraw" />
       <PrizeDraw draw={draws}/>
       </>
    )   
}