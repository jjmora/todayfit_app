import React, { useEffect, useState } from 'react'

const Card = (props) => {
  const [ filteredPermissions, setFilteredPermissions ] = useState()
  
  const permissionFn = (value) => {
    return value.slice(17)
  }

  useEffect(() => {

    let filteredProps = props.permissions?.filter( (p, k) => {
        return props.franchise.permissions.includes(p.id)
      })
    setFilteredPermissions(filteredProps)

    filterPermissions()
  }, [])

  const filterPermissions = () => {
    console.log('Props Permissions: ', props.permissions)
  }

  const permissionDiv = (obj) => {
    return (
    <article className="col-6 p-2" key={obj.id}>
      <div className="p-3 shadow rounded">
        <img src={obj.image} alt="Today Fit Franchise" width="30px" className="text-primary" />
        <br/>
        <b className=''>{obj.name}</b>
      </div>
    </article>
    )
  }

  const filterData = () => {
    let data = 'init data'
    data = props.permissions?.map( (permission) => {
      <p>{permission.id}</p>
    })
    console.log('Perm Data: ', data)
  }

  return (
    <>

      <div className="col mb-4">
        <div className="card h-100 shadow">
          <img src="https://via.placeholder.com/150" width="150px" className="card-img-top" alt="..."/>
          <div className="card-body">
            <h5 className="card-title">Card title</h5>
            <p className="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>

            <div className="d-flex flex-row flex-wrap">
              {/* < PERMISSION */}
              {/* {
                props.franchise.permissions?.map( (permission) => {
                  return (
                    <article className="col-6 p-2" key={permission}>
                      <p>{ permissionFn(permission)}</p>
                    </article>
                  )
                })
              } */}

              {/* {
                props.franchise.permissions?.map( (p) => {
                  return <p>{permissionFn(p)}</p>
                })
              } */}
              {/* 
              {
                props.permissions?.map( (p) => {
                    return <p>{p}</p>
                  })
                  // .filter( permission => permission.id === '1')
              }     
              */}
              {/* {
                JSON.stringify(props.permissions?.filter( (permission, key) => {
                  return (permission.id = '1')
                }))
              }
              */}

              {/* {
                props.permissions?.map( (permission) => {
                    return (
                      <div>
                        <p>{permission.id}</p>
                        <br/>
                      </div>
                      // if(permission.id.toString() === permissionFn(p)){
                      //   //
                      //   return (
                      //     <article className="col-6 p-2" key={permission.id}>
                      //       <div className="p-3 shadow rounded">
                      //         <img src={permission.image} alt="Today Fit Franchise" width="30px" className="text-primary" />
                      //         <br/>
                      //         <b className=''>{permission.name}</b>
                      //       </div>
                      //     </article>
                      //   )
                      //   //
                      // } else {
                      //   'no'
                      // }
                    )
                  })
              } */}

              {
                props.permissions?.map( (permission) => {
                  return (
                    <article className="col-6 p-2" key={permission.id}>
                      <div className="p-3 shadow rounded">
                        <img src={permission.image} alt="Today Fit Franchise" width="30px" className="text-primary" />
                        <br/>
                        {permission.id}
                        <b className=''>{permission.name}</b>
                      </div>
                    </article>
                  )
                })
              } 
              {/* > PERMISSION */}
            </div>

            <div className='d-flex justify-content-between align-items-center px-4 py-4'>
              <small><img src="https://www.svgrepo.com/show/427089/packet.svg" className="mx-2" width="20px" />{props.franchise.user.email}</small>
              <a href={`/show/${props.franchise.id}`} className='btn btn-outline-success'>
                Go!
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-arrow-down-right-circle ms-2" viewBox="0 0 16 16">
                  <path fillRule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.854 5.146a.5.5 0 1 0-.708.708L9.243 9.95H6.475a.5.5 0 1 0 0 1h3.975a.5.5 0 0 0 .5-.5V6.475a.5.5 0 1 0-1 0v2.768L5.854 5.146z"/>
                </svg>
              </a>
            </div>

          </div>

          <div className="card-footer">
            <small className="text-muted">Franchisé depuis le { props.franchise.date }</small>
          </div>

        </div>
      </div>

      <div className='col-md-5 col-lg-4 px-5'>
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

          <div className='card-body'>
            <p className='card-text pt-4 text-justify'>
              {props.franchise.description}
            </p>





          </div>

        </div>
      </div>
    </>
    
  )
}

export default Card




