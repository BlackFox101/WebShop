import classes from './SearchField.module.css';
import {useState} from 'react';
import {IoIosArrowDown} from 'react-icons/io';
import {AiOutlineSearch} from 'react-icons/ai';

const categoryType = {
  shop: 'shops',
  product: 'products',
  user: 'users',
}

/**
 * @param {{
 *   text: string,
 *   onSelect: function(void):void,
 *   selected: boolean,
 * }} props
 */
function DropDownItem({
  text,
  onSelect,
  selected,
}) {
  return (
      <div className={[classes.dropDownItem, selected ? classes.selected : null].join(' ')} onClick={onSelect}>
        {text}
      </div>
  )
}

function SearchField() {
  const [category, setCategory] = useState(categoryType.shop)
  const [showDropdown, setShowDropdown] = useState(false)

  function onCategorySelect(type) {
    setCategory(type)
    setShowDropdown(false)
  }

  return (
      <div className={classes.searchField}>
        <input className={classes.searchInput} type={'text'} placeholder={'Поиск'} />
        <div className={classes.buttonWrapper}>
          <div style={{display: 'flex'}} onClick={() => setShowDropdown(!showDropdown)}>
            <button className={classes.categoryButton}>{category}</button>
            <IoIosArrowDown className={classes.arrowIcon} />
          </div>
          <AiOutlineSearch className={classes.searchIcon}/>
        </div>
        <div className={[classes.dropDownList, showDropdown ? null : classes.hidden].join(' ')}>
          {Object
              .keys(categoryType)
              .map(type => (
                  <DropDownItem
                      text={categoryType[type]}
                      onSelect={() => onCategorySelect(categoryType[type])}
                      selected={category === categoryType[type]}
                      key={type}
                  />)
              )
          }
        </div>
      </div>
  )
}

export {
  SearchField,
}