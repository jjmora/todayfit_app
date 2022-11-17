import React, { useEffect, useState } from 'react'
import axios from 'axios'

const Franchises = (props) => {
  const [ allFranchises, setAllFranchises ] = useState()
  const [ filteredFranchises, setFilteredFranchises ] = useState()
  const [ inputValue, setInputValue ] = useState('')
  const [ activeState, setActiveState ] = useState('all')
  

  const baseUrl = 'http://localhost:8000/franchise'
  const currBaseUrl = window.location.href

  // Load Data at document loading
  useEffect( () => {
    axios.get(`${baseUrl}/franchise_json`)
      .then(response => {
        console.log('Initial Data: ', response.data.franchises)
        setAllFranchises(response.data.franchises)
        setFilteredFranchises(response.data.franchises)
      })
      .catch((error) => {
        console.log(error);
      })
  }, [])

  const handleClick = (e) => {
    setActiveState(e.target.id)
  }
  
  const handleInputField = (e) => {
    setInputValue(e.target.value)

  }

  useEffect( () => {
    let dataByInput
    if(inputValue) {
      dataByInput = allFranchises.filter( (fr, k) => {
        return ( (fr.user.email.includes(inputValue)) || (fr.email.includes(inputValue)) )
      })
    } else {
      dataByInput = allFranchises
    }
    console.log('Data by input:', dataByInput)

    let dataByActiveState
    if(activeState === 'active'){
      dataByActiveState = dataByInput.filter( (fr, k) => {
        return fr.active === true
      })
    } else if(activeState === 'non-active') {
      dataByActiveState = dataByInput.filter( (fr, k) => {
        return fr.active === false
      })
    } else {
      dataByActiveState = dataByInput
    }
  
    setFilteredFranchises(dataByActiveState)
  }, [activeState, inputValue])

  return (
    <>
      <div>
        <h4>Franchises Filter</h4>
        <ul className='active-filter'>
          <li onClick={handleClick} id="all">All</li>
          <li onClick={handleClick} id="active">Active</li>
          <li onClick={handleClick} id="non-active">Non Active</li>
        </ul>
      </div>

      <div className="input-group mb-3">
        <input 
          id="form-input"
          type="search" 
          className="form-control" 
          placeholder="Entrez le(s) mot(s) clé(s)..." 
          aria-label="Username" 
          aria-describedby="basic-addon1" 
          onChange={handleInputField}
        />
        <span className="input-group-text bg-primary text-white" id="basic-addon1"><i className="bi bi-search"></i></span>
      </div>

      <section>
        <div className="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
        {
          filteredFranchises?.map( (franchise) => {
            return(
              <div className="col mb-4">
                <div className="card h-100">
                  <img src="https://via.placeholder.com/150" width="150px" className="card-img-top" alt="..."/>
                  <div className="card-body">
                    <h5 className="card-title">Card title</h5>
                    <p className="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  </div>
                  <div className="card-footer">
                    <small className="text-muted">Last updated 3 mins ago</small>
                  </div>
                </div>
              </div>
            )
          })
        }
        </div>
      </section>

      <div>
        {
          filteredFranchises?.map( (franchise) => {
            return(
                <div key={franchise.id} className="franchise-wrapper">
                  <h3>{franchise.name}</h3>
                  <p>
                    <b>Email : </b>
                    <span>{franchise.user.email}</span>
                  </p>
                  <p>
                    <b>Email Perso: </b>
                    <span>{franchise.email}</span>
                  </p>
                  <p>
                    <b>Active: </b>
                    {franchise.active ? <span className='active'>Oui</span> : <span className='non-active'>Non</span>}
                  </p>
                </div>
            )}
          )
        }
      </div>
    </>
  )
}


export default Franchises