import { Item } from './Item';

export const ItemList = ({ categories, title = null }) => {
  return (
    <div className="p-6 text-gray-900 min-w-[520px]">
      {title === null ? <></> : <h3 className="py-3 text-xl font-semibold">{title}</h3>}

      {categories?.map((c) => {
        return <Item props={c} key={c.id} />;
      })}
    </div>
  );
};
