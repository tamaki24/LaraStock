import { Item } from './Item';

export const ItemList = ({ items, title = null }) => {
  return (
    <div className="p-6 text-gray-900 min-w-[520px]">
      {title === null ? <></> : <h3 className="py-3 text-xl font-semibold">{title}</h3>}

      {items?.map((item) => {
        return <Item props={item} key={item.id} />;
      })}
    </div>
  );
};
