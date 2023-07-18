import React from 'react'
import styles from './Grid.module.scss'
import classNames from 'classnames/bind'

const cx = classNames.bind(styles)

type ColumnPosition = 'center' | 'left' | 'right'

export interface Column {
  id: string
  value: string | number
  pos?: ColumnPosition
}

export type Header = Column

export type Row = {
  id: string
  columns: Column[]
}

export type GridProps = {
  headers: Header[]
  rows: Row[]
}

const Grid: React.FC<GridProps> = ({ rows, headers }): JSX.Element => {
  return (
    <div className={cx('grid')} style={{ ['--grid-col' as string]: headers.length }}>
      {headers?.map((header) => (
        <div
          key={header.id}
          className={cx('grid__column', 'grid__column_type_header', `grid__column_pos_${header.pos || 'center'}`)}
        >
          {header.value}
        </div>
      ))}
      {rows?.map((row, rindex) => (
        <div key={row.id} className={cx('grid__row', rindex % 2 === 0 ? 'grid__row_sec_black' : 'grid__row_sec_white')}>
          {row.columns.map((column) => (
            <div key={column.id} className={cx('grid__column', `grid__column_pos_${column.pos || 'center'}`)}>
              {column.value}
            </div>
          ))}
        </div>
      ))}
    </div>
  )
}

export default Grid
