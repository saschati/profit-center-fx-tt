import React from 'react'
import Grid, { type GridProps } from './Grid'
import styles from './Table.module.scss'

type Filter = {
  FilterComponent: React.FC
}

export type TableProps = {
  grid: GridProps
  filters?: Filter[]
}

const Table: React.FC<TableProps> = ({ grid, filters }): JSX.Element => {
  return (
    <div className={styles.table}>
      {filters && (
        <div className={styles.table__filter}>
          {filters.map((filter, index) => (
            <div key={index} className={styles.table__filterItem}>
              <filter.FilterComponent />
            </div>
          ))}
        </div>
      )}
      <div className={styles.table__grid}>
        <Grid {...grid} />
      </div>
    </div>
  )
}

export default Table
