import { FaWhatsapp } from 'react-icons/fa';

import { useNavigate } from 'react-router-dom';

import React, { useEffect, useState } from 'react';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import Typography from '@mui/material/Typography';
import Modal from '@mui/material/Modal';

import './styles.css';

import api from '../../services/api';


const style = {
    position: 'absolute',
    top: '50%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
    width: 400,
    bgcolor: 'background.paper',
    border: '2px solid #000',
    boxShadow: 24,
    p: 4,
  };

  



export default function PrizeDraw(draws){
       
 const [open, setOpen] = useState(false);
  const handleOpen = () => setOpen(true);
  const handleClose = () => setOpen(false);

  const [drawName, setDrawName] = useState('');
  const [services, setServices] = useState([]);
  const [dateDraw, setDateDraw] = useState('');

  const [draw, setDraw] = useState([]);

  
  const navigate = useNavigate();

  useEffect(() => {
    api
      .get("/draw/services")
      .then((response) => setServices(response.data))
      .catch((err) => {
        console.error("ops! ocorreu um erro" + err);
      });
  }, [open]);

  useEffect(() => {
    api
      .get("/draw")
      .then((response) => setDraw(response.data))
      .catch((err) => {
        console.error("ops! ocorreu um erro" + err);
      });
  }, []);


  //criar sorteio
  const storeDraw = async (e) => {
    e.preventDefault();

    if ((!drawName, !services, !dateDraw)) {
        alert("Todos os campos devem ser informados");
        return;
      }

      try {
        const res = await api.post("/draw", {
          name: drawName,
          service_id: services,
          date_draw: dateDraw
        });

        if (res.status === 200) {
            alert('Sorteio criado com sucesso!')
        }
  
     }catch{
        alert("Erro inesperado ao cadastrar o sorteio!");
     }
  }

function HandleClick(e){
    navigate(`/draw?${e}`);
    
}

    return(
    <section className="container">  
         <Button onClick={handleOpen} style={{ color: 'black', fontSize: 'bold' }}>Criar Novo Sorteio</Button> <h2>Detalhes dos sorteios  🎉</h2>
                {draw.map(item=>{
                    return(
                    <div className="prizeDraw_container">
                    <div id={item.id} onClick={() =>HandleClick(item.id)}  className="prizeDraw_content">
                    <div className="prizeDraw_infos_1">
                        <h3>{item.name}</h3> 
                        <h3> <FaWhatsapp /> {item.name_service}</h3>
                        <h3>{item.finish ? "Finalizado" : "Em andamento"}</h3>
                    </div>
        
                    <div className="prizeDraw_infos_2">   
                        <h3>{item.date_draw}</h3>
                    </div>
                    </div>
                </div>

                    )
                })}
                
    


      <Modal 
        open={open}
        onClose={handleClose}
        aria-labelledby="modal-modal-title"
        aria-describedby="modal-modal-description"
        props={services}
      >
          
        <Box sx={style}>
          <Typography id="modal-modal-title" variant="h6" component="h2" style={{color: 'black', margin: '20px', padding: '8px'}}>
            <h2>Criação de sorteio</h2>
            
            <p>Nome do sorteio</p> <input name='nameDraw' type="text" onChange={(event) => setDrawName(event.target.value)}></input>
            <p>Conexão</p>
               
            <select onChange={(event) => setServices(event.target.value)} type="text" style={{width: '200px'}}>
            {services.map(item=>{
            return(
            <>
            <option key={item.id} style={{overflow: 'hidden', textOverflow: 'ellipsis'}} key={item.id} value={item.id}>{item.name}</option>
            </>
            )               
            })}
            </select>
            
            <p>Data do sorteio</p> <input onChange={(event) => setDateDraw(event.target.value)} type="date"></input>
            
          </Typography>
          <button style={{color: 'black', border: '1px solid black', width: '100px', height: '30px'}} type="button" onClick={storeDraw}>Criar</button>
          <Typography id="modal-modal-description" sx={{ mt: 2 }}>
            
          </Typography>
        </Box>
      </Modal>

    </section>
    )

    
}