import React, { useEffect, useState } from 'react'

const Franchises = (props) => {
  const [ franchises, setFranchises ] = useState(null)
  const [ allFranchises, setAllFranchises ] = useState(null)
  const [ filter, setFilter ] = useState('all')
  const [ inputQuery, setInputQuery ] = useState('')
  // const baseUrl = 'https://admin.todayfit.fr/api'

  // useEffect( () => {
  //   setFranchises(props.allFranchises)
  //   setAllFranchises(props.allFranchises)
  // })

  // useEffect( () => {
  //   if(filter === 'active'){
  //     let activesFranchises = allFranchises.filter( (fr, k) => {
  //       return fr.active === true
  //     })
  //     setFranchises(activesFranchises)
  //   } else if(filter === 'non-active') {
  //     let nonActivesFranchises = allFranchises.filter( (fr, k) => {
  //       return fr.active === false
  //     })
  //     setFranchises(nonActivesFranchises)
  //   }
  // }, [filter])

  // const handleClick = (e) => {
  //   setFilter(e.target.id)
  // }

  // const handleInputField = (e) => {
  //   setInputQuery(e.target.value)
  //   if(setInputQuery === "") return allFranchises
  //   let filteredFranchises = allFranchises.filter( (fr, k) => {
  //     return fr.email.includes(e.target.value)
  //   } )
  //   setFranchises(filteredFranchises)
  // }

  return (
    <>
      <div>
        { JSON.stringify(props.propsFranchises[0]) }
      </div>
    </>
  )
}

export default Franchises