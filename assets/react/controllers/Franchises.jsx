import React, { useEffect, useState } from 'react'
import axios from 'axios'

const Franchises = (props) => {
  const [ allFranchises, setAllFranchises ] = useState()
  const [ filteredFranchises, setFilteredFranchises ] = useState()
  const [ inputValue, setInputValue ] = useState('')
  const [ activeState, setActiveState ] = useState('all')
  
  const [ filterActive, setFilterActive ] = useState('all')
  const [ franchises, setFranchises ] = useState(null)
  
  const [ filteredByInput, setFilteredByInput ] = useState(null)
  const [ filterByClick, setFilterByClick ] = useState(null)

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

  useEffect( () => {
    // if(filterActive === 'active'){
    //   let activesFranchises = filteredByInput.filter( (fr, k) => {
    //     return fr.active === true
    //   })
    //   setFranchises(activesFranchises)
    // } else if(filterActive === 'non-active') {
    //   let nonActivesFranchises = filteredByInput.filter( (fr, k) => {
    //     return fr.active === false
    //   })
    //   setFranchises(nonActivesFranchises)
    // } else {
    //   setFranchises(filteredByInput)
    // }
    filterByActiveState(filterActive, filterByInputValue(inputValue))
  }, [filterActive])



  // const filterValues = (e) => {
  //   // const inputFieldValue = document.querySelector('#form-input')
  //   // input_value + filter
  //   if(e.target.value === "") {
  //     return allFranchises
  //   } else {
  //     filterByInputValue(e.target.value)
  //   }
  // }

  // const handleInputField = (e) => {
  //   if(e.target.value === "") return allFranchises
  //   let filteredFranchises = allFranchises.filter( (fr, k) => {
  //     return fr.email.includes(e.target.value) || fr.user.email.includes(e.target.value)
  //   } )
  //   setFranchises(filteredFranchises)
  // }

  // return Franchises filtered only by "value"
  const filterByInputValue = (value) => {
    console.log('Value form filterByInputValue: ', value)
    if(value) {
      allFranchises.filter( (fr, k) => {
        return ( (fr.user.email.includes(value)) || (fr.email.includes(value)) )
      })
    } else {
      return allFranchises
    }
  }

  //return Franchises filtered by Active State
  const filterByActiveState = (value, data) => {
    if(value === 'active'){
      let activesFranchises = data.filter( (fr, k) => {
        return fr.active === true
      })
      //setFranchises(activesFranchises)
    } else if(value === 'non-active') {
      let nonActivesFranchises = data.filter( (fr, k) => {
        return fr.active === false
      })
      //setFranchises(nonActivesFranchises)
    } else {
      //setFranchises(filteredByInput)
      return data
    }
  }

  const handleClick = (e) => {
    setActiveState(e.target.id)
  }
  
  const handleInputField = (e) => {
    setInputValue(e.target.value)

  }
  useEffect( () => {
    handleFilterForm()
  }, [activeState, inputValue])

  const handleFilterForm = () => {
    console.log('Filter :', activeState)
    console.log('Input Value :', inputValue)
    console.log('Filtered Franchises :', filteredFranchises)
    console.log('All Franchises :', allFranchises)

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
    console.log('DatabyActiveState: ', dataByActiveState)
  }

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