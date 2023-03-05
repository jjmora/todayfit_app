import React, { useEffect, useState } from 'react'

const Card = ({ 
  franchiseId, franchiseName, franchiseDescription, franchiseEmail, franchiseEmailPerso, 
  permissions, franchiseDate, franchiseIsActive, franchiseImage 
}) => {
  
  const handleDateFormat = (unformattedDate) => {
    let newDate = new Date(unformattedDate)
    let yy = newDate.getFullYear()
    let dd = newDate.getDate()
    dd = prependZero(dd)
    let mm = newDate.getMonth()
    mm = prependZero(mm+1)
    const newFormattedDate = `${dd}/${mm}/${yy}`
    return newFormattedDate
  }

  const prependZero = (nb) => {
    if(nb < 10){
      return `0${nb}`
    }
    return nb
  }

  return (
    <>
      <div className="col mb-4">
        <div className="card h-100 shadow">
          { 
            franchiseIsActive == false ? (
              <>
                <div className="overflow image-container no-active-image">
                  <img src={ franchiseImage } alt={`Today Fit ${franchiseName} franchise`} width="150px" className="card-img-top" />
                </div>
                <p className="no-active-message">Non Active</p>
              </>
            ) : (
              <div className="overflow image-container">
                <img src={ franchiseImage } alt={`Today Fit ${franchiseName} franchise`} width="150px" className="card-img-top"/>
              </div>
            ) 
          }
          <div className='box-over d-flex flex-row' >
            <div className='card-body box-over-item'></div>
            <div className='box-over-item-white px-4 py-3 box-over-active'>
              <h4 className='card-title'>{ franchiseName}</h4>
            </div>
          </div>

          <div className="card-body">
            <p className="card-text text-justify">{franchiseDescription}</p>

            <div className="d-flex flex-row flex-wrap">
              {/* < PERMISSION */}
              {
                permissions?.map( (permission) => {
                  return (
                    <article className="col-6 p-2" key={permission.id}>
                      <div className="p-3 shadow rounded d-flex flex-column">
                        <img src={permission.image} alt="Today Fit Franchise" width="30px" className="text-primary" />
                        <b className=''>{permission.name}</b>
                      </div>
                    </article>
                  )
                })
              }
              {/* > PERMISSION */}
            </div>

            <div className='d-flex justify-content-between align-items-center px-4 py-4'>
              <small><img src="https://www.svgrepo.com/show/427089/packet.svg" className="mx-2" width="20px" />{franchiseEmail}</small>
              <a href={`/franchise/show/${franchiseId}`} className='btn btn-outline-success'>
                Go!
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-arrow-down-right-circle ms-2" viewBox="0 0 16 16">
                  <path fillRule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.854 5.146a.5.5 0 1 0-.708.708L9.243 9.95H6.475a.5.5 0 1 0 0 1h3.975a.5.5 0 0 0 .5-.5V6.475a.5.5 0 1 0-1 0v2.768L5.854 5.146z"/>
                </svg>
              </a>
            </div>

          </div>

          <div className="card-footer">
            <small className="text-muted">Franchisé depuis le {handleDateFormat(franchiseDate)}</small>
          </div>

        </div>
      </div>
    </>
    
  )
}

export default Card




