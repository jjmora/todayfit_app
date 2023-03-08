import React, { useEffect, useState } from "react";
import axios from "axios";
import Card from "./Card";
import Pagination from "./Pagination";

const Franchises = () => {
  const [franchisesArray, setFranchisesArray] = useState();
  const [filteredFranchises, setFilteredFranchises] = useState();
  const [inputValue, setInputValue] = useState("");
  const [activeState, setActiveState] = useState("all");
  const [errorOnLoading, setErrorOnLoading] = useState();
  const [loading, setLoading] = useState(true);
  //Pagination
  const [currentPage, setCurrentPage] = useState(1);
  const [postsPerPage, setPostsPerPage] = useState(6);
  const [filteredItemsQty, setFilteredItemsQty] = useState(100);

  // const baseUrl = 'http://localhost:8000'
  // const currBaseUrl = window.location.href

  let dataByInput;
  let dataByActiveState;

  const lastPostIndex = currentPage * postsPerPage; // 1 * 6 = 6
  const firstPostIndex = lastPostIndex - postsPerPage; // 6 - 6 = 0

  // Load Data at document loading
  useEffect(() => {
    axios
      .get(`/franchise/franchise_json`)
      .then((response) => {
        //console.log("Initial Data: ", response.data);
        setFranchisesArray(response.data.franchisesArray);
        setFilteredFranchises(
          response.data.franchisesArray.slice(firstPostIndex, lastPostIndex)
        );
        setFilteredItemsQty(response.data.franchisesArray.length);
        setLoading(false);
      })
      .catch((error) => {
        //console.log(error);
        setErrorOnLoading("Une erreur c'est produite");
      });
  }, []);

  const handleFilterClick = (e) => {
    setActiveState(e.target.id);
    // give CSS classes for formatting
    let parent = e.currentTarget.parentElement;
    //console.log(parent);
    let children = parent.children;
    //console.log(children);
    for (let child of children) {
      child.classList.remove("filter-active");
    }
    e.target.classList.add("filter-active");
  };

  const handleInputField = (e) => {
    setInputValue(e.target.value);
  };

  useEffect(() => {
    // console.log("FilteredFranchises: ", filteredFranchises);
    // Filter dat by User Input - by inputValue

    if (inputValue) {
      let lowerCaseInputValue = inputValue.toLowerCase();
      dataByInput = franchisesArray?.filter((fr, k) => {
        let email = fr.email;
        email = email.toLowerCase();
        let email_perso = fr.email_perso;
        email_perso = email_perso.toLowerCase();
        let name = fr.name;
        name = name.toLowerCase();
        return (
          email.includes(lowerCaseInputValue) ||
          email_perso.includes(lowerCaseInputValue) ||
          name.includes(lowerCaseInputValue)
        );
      });
    } else {
      dataByInput = franchisesArray;
    }

    // by activeState
    if (activeState === "active") {
      dataByActiveState = dataByInput?.filter((fr, k) => {
        return fr.isActive === true;
      });

      setFilteredItemsQty(dataByActiveState?.length);
    } else if (activeState === "non-active") {
      dataByActiveState = dataByInput?.filter((fr, k) => {
        return fr.isActive === false;
      });

      setFilteredItemsQty(dataByActiveState?.length);
    } else {
      dataByActiveState = dataByInput;

      setFilteredItemsQty(dataByActiveState?.length);
    }

    let currentPosts = dataByActiveState;
    if (dataByActiveState?.length > 6) {
      currentPosts = dataByActiveState?.slice(firstPostIndex, lastPostIndex);
    }

    setFilteredFranchises(currentPosts);
  }, [activeState, inputValue, currentPage]);

  return (
    <>
      <div className="d-flex flex-column flex-xl-row justify-content-md-between align-items-center my-5">
        <div className="d-flex col-12 col-lg-5 flex-sm-row justify-content-center justify-content-lg-start mb-sm-2 mb-md-3 mb-xl-0">
          <h2 className="fw-bold lh-1 mb-0 me-md-3 text-uppercase mb-2 me-4">
            MES CLUBS
          </h2>
          <h2 className="fw-bold lh-1 mb-4 mb-sm-0 text-uppercase strokeme">
            TODAYFIT
          </h2>
        </div>

        <div className="col-12 col-xl-4 form-search">
          <div>
            <ul className="d-flex flex-row justify-content-center active-filter">
              <li
                onClick={handleFilterClick}
                className="filter-active"
                id="all"
              >
                Tout
              </li>
              <li onClick={handleFilterClick} className="" id="active">
                Active
              </li>
              <li onClick={handleFilterClick} className="" id="non-active">
                Non Active
              </li>
            </ul>
          </div>
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
          <span
            className="input-group-text bg-primary text-white"
            id="basic-addon1"
          >
            <i className="bi bi-search"></i>
          </span>
        </div>
      </div>

      <div>
        <p>{errorOnLoading}</p>
      </div>
      {loading ? (
        <div className="d-flex justify-content-center mb-5">
          <div className="lds-grid">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
          </div>
        </div>
      ) : (
        <section>
          <div className="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            {filteredFranchises?.map((franchise, key) => {
              return (
                <Card
                  key={key}
                  franchiseId={franchise.id}
                  franchiseName={franchise.name}
                  franchiseEmail={franchise.email}
                  franchiseEmailPerso={franchise.email_perso}
                  permissions={franchise.permissions}
                  franchiseDate={franchise.date}
                  franchiseIsActive={franchise.isActive}
                  franchiseImage={franchise.image}
                  franchiseDescription={franchise.description}
                />
              );
            })}
          </div>
        </section>
      )}

      <nav className="pagination-section d-flex justify-content-center mb-3">
        {filteredItemsQty > 6 ? (
          <Pagination
            totalPosts={franchisesArray?.length}
            postsPerPage={postsPerPage}
            setCurrentPage={setCurrentPage}
            currentPage={currentPage}
            filteredItemsQty={filteredItemsQty}
          />
        ) : (
          ""
        )}
      </nav>
    </>
  );
};

export default Franchises;
