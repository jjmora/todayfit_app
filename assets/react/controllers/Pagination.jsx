import React, { useState, useEffect } from "react";

const Pagination = ({
  totalPosts,
  postsPerPage,
  setCurrentPage,
  currentPage,
}) => {
  const [pages, setPages] = useState([]);
  let pagesArray = [];

  useEffect(() => {
    if (totalPosts) {
      // console.log("totalPosts :", totalPosts);
    }
    // console.log("PostPerPage: ", postsPerPage);
    for (let i = 1; i <= Math.ceil(totalPosts / postsPerPage); i++) {
      pagesArray.push(i);
    }
    setPages(pagesArray);
  }, [totalPosts]);

  return (
    <div>
      <nav aria-label="Page navigation example">
        <ul className="pagination">
          {currentPage > 1 ? (
            <li className="page-item">
              <button
                aria-label="Previous"
                className="page-link"
                onClick={() => setCurrentPage(currentPage - 1)}
              >
                <span aria-hidden="true">&laquo;</span>
              </button>
            </li>
          ) : (
            ""
          )}

          {pages.map((page, index) => {
            return (
              <li className="page-item" key={index}>
                <button
                  key={index}
                  className="page-link"
                  onClick={() => setCurrentPage(page)}
                >
                  {page}
                </button>
              </li>
            );
          })}

          {currentPage < Math.ceil(totalPosts / postsPerPage) ? (
            <li className="page-item">
              <button
                aria-label="Next"
                className="page-link"
                onClick={() => setCurrentPage(currentPage + 1)}
              >
                <span aria-hidden="true">&raquo;</span>
              </button>
            </li>
          ) : (
            ""
          )}
        </ul>
      </nav>
    </div>
  );
};

export default Pagination;
