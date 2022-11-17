import React from 'react'

const Card = (props) => {
  return (
      <div layout className='col-md-5 col-lg-4 px-5'>
        <div className='card shadow'>
          { props.franchise.active == false ? (
              <>
                <div className="overflow image-container no-active-image">
                  <img src={ props.franchise.image } alt="Today Fit Franchise" width="150px" className="card-img-top" />
                </div>
                <p className="no-active-message">Non Active</p>
              </>
            ) : (
              <div className="overflow image-container">
                <img src={ props.franchise.image } alt="Today Fit Franchise" width="150px" className="card-img-top"/>
              </div>
            ) 
          }
          <div className='box-over d-flex flex-row' >
            <div className='card-body box-over-item'></div>
            <div className='box-over-item-white px-4 py-3 box-over-active'>
              {/* <h4 className='card-title'>{ props.franchise_name}</h4> */}
              <h4 className='card-title'>{ props.franchise.name}</h4>
            </div>
          </div>

          <div class='card-body'>
            <p class='card-text pt-4 text-justify'>
              {props.franchise.description}
            </p>

            <div class="d-flex flex-row flex-wrap">
              {/* < PERMISSION */}
              {/* {
                props.permissions?.map( (permission) => {
                  return (
                    <article class ="col-6 p-2">
                      <div class="p-3 shadow rounded">
                        <img src={permission.image} alt="Today Fit Franchise" width="30px" class="text-primary" />
                        <br/>
                        <b class=''>{permission.name}</b>
                      </div>
                    </article>
                  )
                })
              } */}
              {/* > PERMISSION */}
            </div>

            <div class='d-flex justify-content-between align-items-center px-4 pt-4'>
        
              <small><img src="https://www.svgrepo.com/show/427089/packet.svg" class="mx-2" width="20px" />{props.franchise.email}</small>
              <a href="#" class='btn btn-outline-success'>
                Go!
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-right-circle ms-2" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.854 5.146a.5.5 0 1 0-.708.708L9.243 9.95H6.475a.5.5 0 1 0 0 1h3.975a.5.5 0 0 0 .5-.5V6.475a.5.5 0 1 0-1 0v2.768L5.854 5.146z"/>
                </svg>
              </a>
            </div>

          </div>

          <div class="card-footer">
            <small class="text-muted">Franchisé depuis le { props.franchise.date }</small>
          </div>


        </div>
      </div>
  )
}

export default Card




