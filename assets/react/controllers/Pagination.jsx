import React, { useState, useEffect } from "react";

const Pagination = ({ totalPosts, postsPerPage, setCurrentPage }) => {
  const [pages, setPages] = useState([]);
  let pagesArray = [];

  useEffect(() => {
    if (totalPosts) {
      console.log("totalPosts :", totalPosts);
    }
    console.log("PostPerPage: ", postsPerPage);
    for (let i = 1; i <= Math.ceil(totalPosts / postsPerPage); i++) {
      pagesArray.push(i);
    }
    setPages(pagesArray);
  }, [totalPosts]);


  return (
    <div>
      {/* <ul>
        {pages.map((page, index) => {
          return (
            <li key={index} class="page-item">
              <a className="page-link" href="">
                {page}
              </a>
            </li>
          );
        })}
      </ul> */}
      {
        pages.map( (page, index) => {
          return (<button key={index} onClick={ () => setCurrentPage(page)}>{page}</button>)
        })
      }
    </div>
  );
};

export default Pagination;
