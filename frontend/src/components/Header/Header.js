import React from 'react';
import "./styles.css";
import Logo from "../../assets/images/logo.png";

export default function Header(){

        return(
            <header className="container_header">
                <section className="logo">
                    <img src={Logo} alt="Logo Bot Zap"></img>
                </section>  
            </header>
        )
    
}
