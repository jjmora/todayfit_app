import React, { useEffect, useState } from 'react'
import axios from 'axios'

const Franchises = (props) => {
  const [ franchises, setFranchises ] = useState(null)
  const [ allFranchises, setAllFranchises ] = useState(null)
  const [ filter, setFilter ] = useState('all')
  const [ inputQuery, setInputQuery ] = useState('')
  const baseUrl = 'http://localhost:8000/franchise'
  const currBaseUrl = window.location.href

  useEffect( () => {
    axios.get(`${baseUrl}/franchise_json`)
      .then(response => {
        setFranchises(response.data.franchises)
        setAllFranchises(response.data.franchises)
        console.log(response.data.franchises)
        // setFranchises(response.data['hydra:member'])
        // setAllFranchises(response.data['hydra:member'])
      })
      .catch((error) => {
        console.log(error);
      })
  }, [])

      // const baseUrl = 'https://admin.todayfit.fr/api'

      // useEffect( () => {
      //   setFranchises(props.allFranchises)
      //   setAllFranchises(props.allFranchises)
      // })

  useEffect( () => {
    if(filter === 'active'){
      let activesFranchises = allFranchises.filter( (fr, k) => {
        return fr.active === true
      })
      setFranchises(activesFranchises)
    } else if(filter === 'non-active') {
      let nonActivesFranchises = allFranchises.filter( (fr, k) => {
        return fr.active === false
      })
      setFranchises(nonActivesFranchises)
    }
  }, [filter])

  const handleClick = (e) => {
    setFilter(e.target.id)
  }

  const handleInputField = (e) => {
    if(e.target.value === "") return allFranchises
    let filteredFranchises = allFranchises.filter( (fr, k) => {
      return fr.email.includes(e.target.value) || fr.user.email.includes(e.target.value)
    } )
    setFranchises(filteredFranchises)
  }

  return (
    <>
      <div>
        <h4>Franchises Filter</h4>
        <ul className='active-filter'>
          <li onClick={handleClick} id="active">Active</li>
          <li onClick={handleClick} id="non-active">Non Active</li>
        </ul>
      </div>
      <div className='search-input-wrapper'>
        <input 
          type="search" 
          className='search-input' 
          placeholder='Please enter your text here...'
          onChange={handleInputField}
        ></input>
      </div>
      <div>
        {
          franchises?.map( (franchise) => {
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