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
        
        setFranchises(response.data.franchises)
        setFilteredByInput(response.data.franchises)
        setFilterByClick(response.data.franchises)
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
      <div className='search-input-wrapper'>
        <input 
          id="form-input"
          type="search" 
          className='search-input' 
          placeholder='Please enter your text here...'
          onChange={handleInputField}
        ></input>
      </div>
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