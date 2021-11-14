import React from 'react'
import classes from './CardContainer.module.css';

/**
 * @param {{
 *   title: string,
 * }}
 */
function CardContainer({
    title,
    children
}) {
  return (
      <div className={classes.cardContainer}>
        <div className={classes.title}>{title}</div>
        {children}
      </div>
  )
}

export {
  CardContainer,
}